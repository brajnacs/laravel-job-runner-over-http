<?php

namespace BrajMohan\LaravelJobRunnerOverHttp\Controllers;

use BrajMohan\LaravelJobRunnerOverHttp\Requests\FireJobRequest;
use Illuminate\Queue\Jobs\JobName;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class JobRequestController extends Controller
{
    public function fireJob(FireJobRequest $request)
    {
        $payload = $this->payload($request->payload);

        if ($this->isLaravelJob($payload)) {
            $jobClassName = $payload['displayName'];
            Log::info("Processing: " . $jobClassName);
            $command = $this->getCommand($payload);
            $command->handle();
        } else {
            $jobClassName = $this->getJobClass($request->get('connection'), $request->get('queue'));
            Log::info("Processing: " . $jobClassName);
            (new $jobClassName('foo', $payload))->handle();
        }

        Log::info("Processed: " . $jobClassName);

        return response($jobClassName);
    }

    public function getJobClass($connectionName, $queueName): string
    {
        $queues = $this->getQueueList($this->getConnectionName($connectionName));

        return $queues[$queueName];
    }

    private function getQueueList($connectionName)
    {
        if ($connectionName === "stomp") {
            return config("queue.connections.${connectionName}.stomp-config.queues");
        }

        $queueName = config("queue.connections.${connectionName}.queue");

        return [$queueName => $queueName];
    }

    private function isLaravelJob($payload): bool
    {
        try {
            [$class, $method] = JobName::parse($payload['job']);

            return class_exists($class);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function payload($payload)
    {
        return json_decode($payload, true);
    }

    private function getConnectionName($connectionName)
    {
        if ($connectionName) {
            return $connectionName;
        }

        if ($this->isLaravelJob($this->payload(request()->get('payload')))) {
            return config('queue.default');
        }

        return 'stomp';
    }

    private function getCommand($payload)
    {
        $command = unserialize($payload['data']['command']);

        return $command;
    }
}

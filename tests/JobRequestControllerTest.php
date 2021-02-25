<?php

namespace BrajMohan\LaravelJobRunnerOverHttp\Tests;

use BrajMohan\LaravelJobRunnerOverHttp\Controllers\JobRequestController;
use BrajMohan\LaravelJobRunnerOverHttp\Requests\FireJobRequest;
use Illuminate\Support\Facades\Config;

class JobRequestControllerTest extends TestCase
{
    /** @test */
    public function testFiringLaravelNativeJob()
    {
        $jobRequestController = $this->app->make(JobRequestController::class);

        $jobRequest = new FireJobRequest();
        $jobRequest->setMethod('POST');
        $jobRequest->request->add(['payload' => '{"displayName":"BrajMohan\\\\LaravelJobRunnerOverHttp\\\\Tests\\\\SampleJob","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"BrajMohan\\\\LaravelJobRunnerOverHttp\\\\Tests\\\\SampleJob","command":"O:50:\"BrajMohan\\\\LaravelJobRunnerOverHttp\\\\Tests\\\\SampleJob\":8:{s:6:\"\u0000*\u0000job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:5:\"delay\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}}"}}']);
        $jobRequest->json();

        $response = $jobRequestController->fireJob($jobRequest);
        $this->assertEquals($response->getContent(), "BrajMohan\LaravelJobRunnerOverHttp\Tests\SampleJob");
    }

    public function testFiringEventJob()
    {
        Config::set('queue.connections.stomp.stomp-config.queues', [
            '/queue/BogusHeadQueue' => 'BogusHeadClass',
            '/queue/ApplicationQueue' => SampleEvent::class,
            '/queue/BogusTailQueue' => 'BogusTailClass',
        ]);

        $jobRequestController = $this->app->make(JobRequestController::class);
        $jobRequest = new FireJobRequest();
        $jobRequest->setMethod('POST');
        $jobRequest->request->add([
            'queue' => '/queue/ApplicationQueue',
            'payload' => json_encode(['foo' => 'bar'])
        ]);

        $response = $jobRequestController->fireJob($jobRequest);
        $this->assertEquals($response->getContent(), "BrajMohan\LaravelJobRunnerOverHttp\Tests\SampleEvent");
    }
}

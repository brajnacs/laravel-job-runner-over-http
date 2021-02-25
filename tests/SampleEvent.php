<?php
namespace BrajMohan\LaravelJobRunnerOverHttp\Tests;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SampleEvent implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $topic;

    public $data;

    public function __construct(string $topic, array $data)
    {
        $this->topic = $topic;
        $this->data = collect($data);
    }

    public function handle()
    {
        return "handled";
    }
}

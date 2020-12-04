<?php

namespace warehouse\Console\Commands;

use Illuminate\Console\Command;

class EnsureQueueListenerIsRunning extends Command
{
    
    /**
     * @Author artexs developers
     * Live Queue working
     * @MIT Lincense
     */
    protected $signature = 'workers:webhooks';
    protected $pidFile;
    protected $description = 'Memastikan proses berjalan diserver.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->pidFile = __DIR__ . '/queue.pid';

        if (! $this->isWorkerRunning()) {
            $this->comment('Queue worker is being started.');
            $pid = $this->startWorker();
            $this->saveWorkerPID($pid);
        }
        $this->comment('Queue worker is running.');
    }

    private function isWorkerRunning(): bool
    {
        if (! $pid = $this->getLastWorkerPID()) {
            return false;
        }
        $process = exec("ps -p {$pid} -opid=,command=");
        $processIsQueueWorker = str_contains($process, 'queue:work');

        return $processIsQueueWorker;
    }
    
    private function saveWorkerPID($pid)
    {
        file_put_contents($this->pidFile, $pid);
    }

    private function getLastWorkerPID()
    {
        if (! file_exists($this->pidFile)) {
            return false;
        }

        return file_get_contents($this->pidFile);
    }

    private function saveQueueListenerPID($pid)
    {
        file_put_contents('/queue.pid', $pid);
    }
    
    private function startWorker()
    {
        $command = 'php ' . base_path() . '/artisan queue:work --memory=500 --timeout=360 > /dev/null & echo $!';
        $pid = exec($command);

        return $pid;
    }
}
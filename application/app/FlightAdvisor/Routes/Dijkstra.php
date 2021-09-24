<?php

namespace App\FlightAdvisor\Routes;

class Dijkstra implements IRoute
{
    protected $graph;

    protected $distance;

    protected $previous;

    protected $queue;

    protected function processNextNodeInQueue(array $exclude)
    {
        $closest = array_search(min($this->queue), $this->queue);
        if (!empty($this->graph[$closest]) && !in_array($closest, $exclude)) {
            foreach ($this->graph[$closest] as $neighbor => $cost) {
                if (isset($this->distance[$neighbor])) {
                    if ($this->distance[$closest] + $cost < $this->distance[$neighbor]) {
                        $this->distance[$neighbor] = $this->distance[$closest] + $cost;
                        $this->previous[$neighbor] = array($closest);
                        $this->queue[$neighbor] = $this->distance[$neighbor];
                    } elseif ($this->distance[$closest] + $cost === $this->distance[$neighbor]) {
                        $this->previous[$neighbor][] = $closest;
                        $this->queue[$neighbor] = $this->distance[$neighbor];
                    }
                }
            }
        }
        unset($this->queue[$closest]);
    }

    protected function extractPaths($target)
    {
        $paths = array(array($target));
        for ($key = 0; isset($paths[$key]); ++$key) {
            $path = $paths[$key];
            if (!empty($this->previous[$path[0]])) {
                foreach ($this->previous[$path[0]] as $previous) {
                    $copy = $path;
                    array_unshift($copy, $previous);
                    $paths[] = $copy;
                }
                unset($paths[$key]);
            }
        }
        return array_values($paths);
    }

    public function shortestPaths(array $graphArray, $source, $target, array $exclude = array())
    {
        $this->graph = $graphArray;
        $this->distance = array_fill_keys(array_keys($this->graph), INF);
        $this->distance[$source] = 0;
        $this->previous = array_fill_keys(array_keys($this->graph), array());
        $this->queue = array($source => 0);
        while (!empty($this->queue)) {
            $this->processNextNodeInQueue($exclude);
        }
        if ($source === $target) {
            return array(array($source));
        } elseif (empty($this->previous[$target])) {
            return array();
        } else {
            return $this->extractPaths($target);
        }
    }
}

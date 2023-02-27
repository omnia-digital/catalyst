<?php namespace App\Metrics\TimeFilters;

class TimeFilterRegistry
{
    protected array $timeFilters = [];

    public function register(string $name, TimeFilter $filterClass)
    {
        $this->timeFilters[$name] = $filterClass;

        return $this;
    }

    public function get(string $name): TimeFilter
    {
        if (!array_key_exists($name, $this->timeFilters)) {
            throw new \InvalidArgumentException('Invalid time filter: ' . $name);
        }

        return $this->timeFilters[$name];
    }

    public function options(): array
    {
        foreach ($this->timeFilters as $key => $timeFilter) {
            $options[$key] = $timeFilter->name();
        }

        return $options ?? [];
    }
}

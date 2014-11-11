<?php

namespace Insider\AppBundle\Utils;

class LeagueTourGenerator
{
    private $commands;

    private $commandsCount;

    private $tours;

    public function __construct(array $commands)
    {
        $this->commands = $commands;
        $this->commandsCount = count($this->commands);
    }

    public function generateCircle()
    {
        if (0 !== $this->commandsCount % 2) {
            throw new \LogicException('Can generate circle tour table only for even command count.');
        }

        // get half commands arrays to build tour
        list($l, $r) = array_chunk(
            $this->commands,
            $this->commandsCount / 2
        );

        $i = count($this->tours);

        $lapTourCount = $this->commandsCount - 1;

        while ($i < $lapTourCount * 2) {
            // reset array keys
            $r = array_values($r);
            $l = array_values($l);

            if ($i < $lapTourCount) {
                $this->tours[] = [$l, array_reverse($r)];
            } else {
                $this->tours[] = [$r, array_reverse($l)];
            }

            /**
             * Make clockwise displacement between left and right array elements
             * with saving first element of left array
             */
            array_push($l, array_shift($r));
            array_push($r, $l[1]);
            unset($l[1]);

            $i++;
        }

        return $this->tours;
    }
}

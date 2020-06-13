<?php

namespace App\Service;

class Pager
{
    public function getPagination($count, $active, $sort, $direction)
    {
        $currentQ = 1;
        $page = 1;
        $items = [];

        while ($currentQ <= $count) {
            if ($page == $active) {
                $items[$page] = [
                    'isCurrent' => TRUE,
                    'href' => '#'
                ];
            } else {
                $href = '/page/' . $page;

                if ($sort !== 'id') {
                    $href = '/';

                    if ('page' !== 1) {
                        $href = '/page/' . $page . '/sort/' . $sort . '/direction/' . $direction;
                    }
                }

                $items[$page] = [
                    'isCurrent' => FALSE,
                    'href' => $href,
                ];
            }

            $page++;
            $currentQ += 3;
        }
        return $items;
    }
}
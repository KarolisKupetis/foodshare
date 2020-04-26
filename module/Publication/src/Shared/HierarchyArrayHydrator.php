<?php

namespace Publication\Shared;

use Doctrine\ORM\Internal\Hydration\ArrayHydrator;

class HierarchyArrayHydrator extends ArrayHydrator
{
    /**
     * @inheritdoc
     */
    protected function hydrateAllData()
    {
        $result = parent::hydrateAllData();

        foreach ($result as &$item) {
            $this->alignNesting($item);
        }

        return $result;
    }

    /**
     * @param array $result
     */
    private function alignNesting(array &$result): void
    {
        if (isset($result[0])) {
            $result = array_replace_recursive($this->nestItemData($result), $result[0]);
            unset($result[0]);
        }
    }

    /**
     * @param array $item
     * @return array
     */
    private function nestItemData(array $item): array
    {
        $data = $temp = [];

        foreach ($item as $key => $value) {
            foreach (array_reverse(explode('_', $key)) as $level) {
                $temp = [$level => $value];
                $value = $temp;
            }

            $data = array_replace_recursive($data, $temp);
        }

        return $data;
    }
}
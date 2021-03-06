<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Element
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Model\DataObject\Traits;

trait ElementWithMetadataComparisonTrait
{
    /**
     * @param $array1
     * @param $array2
     * @return bool
     */
    public function isEqual($array1, $array2) {
        $count1 = is_array($array1) ? count($array1) : 0;
        $count2 = is_array($array2) ? count($array2) : 0;
        
        if ($count1 != $count2) {
            return false;
        }

        $values1 = array_filter(array_values(is_array($array1) ? $array1 : []));
        $values2 = array_filter(array_values(is_array($array2) ? $array2 : []));

        for ($i = 0; $i < $count1; $i++) {
            /** @var  $container1 DataObject\Data\ElementMetadata */
            $container1 = $values1[$i];
            /** @var  $container2 DataObject\Data\ElementMetadata */
            $container2 = $values2[$i];

            if (!$container1 && $container2 || $container1 && !$container2) {
                return false;
            }
            if (!$container1 && !$container2) {
                return true;
            }

            /** @var  $el1 Element\ElementInterface */
            $el1 = $container1->getElement();
            /** @var  $el2 Element\ElementInterface */
            $el2 = $container2->getElement();

            if (! ($el1->getType() == $el2->getType() && ($el1->getId() == $el2->getId()))) {
                return false;
            }

            $data1 = $container1->getData();
            $data2 = $container2->getData();
            if (serialize($data1) != serialize($data2)) {
                return false;
            }
        }

        return true;
    }

}

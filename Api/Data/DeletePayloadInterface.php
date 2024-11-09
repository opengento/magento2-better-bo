<?php


namespace Opengento\BetterBo\Api\Data;

interface DeletePayloadInterface
{
    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return mixed
     */
    public function setEntityId(int $entityId);

    /**
     * @return mixed
     */
    public function getStoreViewId();

    /**
     * @param int $storeViewId
     * @return mixed
     */
    public function setStoreViewId(int $storeViewId);

    /**
     * @return mixed
     */
    public function getAttributeCode();

    /**
     * @param string $attributeCode
     * @return mixed
     */
    public function setAttributeCode(string $attributeCode);

}

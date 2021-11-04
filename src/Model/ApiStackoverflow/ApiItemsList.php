<?php
    namespace App\Model\ApiStackoverflow;

    use Spatie\DataTransferObject\FlexibleDataTransferObject;

    class ApiItemsList extends FlexibleDataTransferObject
    {
        /**
         * @var int
         */
        public int $id;
    
        /**
         * @var array
         */
        public array $items;

        /**
         * @var bool
         */
        public bool $has_more;

        /**
         * @var int
         */
        public int $quota_max;

        /**
         * @var int
         */
        public int $quota_remaining;

        /**
         * @param array $userObject
         * @return static
         */
        public static function fromApiResult(array $userItemsList): self
        {
            return new self($userItemsList);
        }
    }
?>
<?php

namespace Training\Helloworld\Plugin\Model\Data;

class Customer
{

    public function beforeSetFirstname(\Magento\Customer\Model\Data\Customer $subject, $value)
    {
        return [mb_convert_case($value, MB_CASE_TITLE)];
    }

}
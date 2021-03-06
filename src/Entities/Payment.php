<?php
namespace Kameli\Quickpay\Entities;

/**
 * @property int id
 * @property int merchant_id
 * @property string order_id
 * @property bool accepted
 * @property string type
 * @property string text_on_statement
 * @property int branding_id
 * @property array variables
 * @property string currency
 * @property string state
 * @property object metadata
 * @property object link
 * @property string shipping_address
 * @property string invoice_address
 * @property array basket
 * @property array operations
 * @property bool test_mode
 * @property string acquirer
 * @property string facilitator
 * @property string created_at
 * @property int balance
 */
class Payment extends Entity
{
    /**
     * Check if a payment has been authorized
     * @return bool
     */
    public function authorized()
    {
        return $this->accepted && ! $this->test_mode;
    }

    /**
     * Check if a test payment has been authorized
     * @return bool
     */
    public function authorizedTest()
    {
        return $this->accepted && $this->test_mode;
    }

    /**
     * Get a specific variable
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function variable($name, $default = null)
    {
        return isset($this->variables->{$name}) ? $this->variables->{$name} : $default;
    }

    /**
     * Get the authorized amount
     * @return float
     */
    public function amount()
    {
        foreach ($this->operations as $operation) {
            if ($operation->type == 'authorize') {
                return $operation->amount / 100;
            }
        }

        return null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
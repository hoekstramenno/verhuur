<?php namespace App;


class Reservation {

    public function __construct($date, $pax, $mail)
    {
        $this->date = $date;
        $this->pax = $pax;
        $this->email = $mail;
    }

    /**
     * Create option from a reservation
     *
     * @param $paymentGateway
     * @param $paymentToken
     * @return App
     */
    public function toOption($paymentGateway, $paymentToken)
    {
        $paymentGateway->charge($this->totalCosts(), $paymentToken);
        return Option::forDate($this->date, $this->email, $this->pax, $this->totalCosts());
    }

    /**
     * Return the total costs
     *
     * @return mixed
     */
    public function totalCosts()
    {
        return $this->pax * $this->date->price;
    }

    /**
     * Getter for the date
     *
     * @return mixed
     */
    public function date()
    {
        return $this->date;
    }

    /**
     * Getter for the email
     *
     * @return mixed
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * Getter for the pax
     *
     * @return mixed
     */
    public function pax()
    {
        return $this->pax;
    }

}
<?php


class InqueryQuestion extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var string
     *
     */
    public $topic;

    /**
     * @var string
     *
     */
    public $options;

    /**
     * @var integer
     *
     */
    public $is_radio;


}

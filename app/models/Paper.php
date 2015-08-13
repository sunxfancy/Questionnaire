<?php


class Paper extends \Phalcon\Mvc\Model 
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
    public $description;

    /**
     * @var string
     *
     */
    public $name;

    public function initialize()
    {
        $this->hasMany("id", "Factor", "paper_id");
    }

    public static function findByNames($names)
    {
        $papers = self::find(array(
            'name IN ({names:array})',
            'bind' => array('names' => $names)
        ));
        return $papers;
    }
}

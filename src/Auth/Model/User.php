<?php

namespace Auth\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class User
 * @package Auth\Model
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class User implements InputFilterAwareInterface
{
    const TABLE = 'user';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $valid;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * Set the inputFilter described into __construct method.
     *
     * @param InputFilterInterface $inputFilter
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array (
                    'name' => 'Int',
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
                'required' => true,
                'filters' => array (
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'password',
                'required' => true,
                'filters' => array (
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'name',
                'required' => true,
                'filters' => array (
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'valid',
                'required' => true,
                'filters' => array (
                    'name' => 'Int',
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'role',
                'required' => true,
                'filters' => array (
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 20,
                    ),
                ),
            )));
            $this->setInputFilter($inputFilter);
        }
        
        return $this->inputFilter;
    }

    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
        foreach($data as $key => $value) {
            $this->{$key} = $value;

        }
    }

    /**
     * Return all entity data in array format
     *
     * @return array
     */
    public function getData()
    {
        $data = get_object_vars($this);
        unset($data['inputFilter']);
        unset($data['tableName']);
        return $data;
    }
}
<?php

namespace Itb;

class Staff
{
    private $id;
    private $aName;
    private $aPassword;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAName()
    {
        return $this->aName;
    }

    /**
     * @param mixed $aName
     */
    public function setAName($aName)
    {
        $this->aName = $aName;
    }

    /**
     * @return mixed
     */
    public function getAPassword()
    {
        return $this->aPassword;
    }

    /**
     * @param mixed $aPassword
     */
    public function setAPassword($aPassword)
    {
        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        return $this->$password_hashed;
    }

    public function __toString()
    {
        $text = '';
        $text .= 'id = ' . $this->id;
        $text .= ', aName = ' . $this->aName;
        $text .= ', aPassword = ' . $this->aPassword;

        return $text;
    }

}
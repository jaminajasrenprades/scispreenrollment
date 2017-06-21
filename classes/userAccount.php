<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserAccount {
    
    private $userid, $username, $password, $name, $type, $email, $idnumber;
    
    /*
     * UserAccount Constructors
     */
    
    public function __construct($userid, $username, $password, $name, $type, $email, $idnumber) {
        $this->userid = $userid;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->type= $type;
        $this->email= $email;
        $this->idnumber= $idnumber;        
    }
    
    //getter and setter methods
    public function getUserId()
    {
        return $this->userid;
    }
    
    public function setUserId($userid)
    {
        $this->userid=$userid;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password){
    $this->password=$password;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
    $this->name=$name;
    }
    
    public function getType(){
        return $this->type;
    }
    public function setType($type){
    $this->type=$type;
    }
    
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
    $this->email=$email;
    }
    
    public function getIdNumber(){
        return $this->idnumber;
    }
    public function setIdNumber($idnumber){
    $this->idnumber=$idnumber;
    }
    //
}

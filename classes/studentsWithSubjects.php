<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class studentsWithSubjects {
    
    private $idnumber, $firstname, $lastname, $course, $year;
    
    public function __construct($idnumber, $firstname, $lastname, $course, $year) {
        $this->idnumber=$idnumber;
        $this->firstname=$firstname;
        $this->lastname = $lastname;
        $this->course = $year;
    }
    
    public function getIdNumber(){
        return $this->idnumber;
    }
    public function setIdNumber($idnumber){
        $this->idnumber=$idnumber;
    }
    
    public function getFirstName(){
        return $this->firstname;
    }
    public function setFirstName($firstname){
        $this->firstname=$firstname;
    }
    
    public function getLastName(){
        return $this->lastname;
    }
    public function setLastName($lastname){
        $this->lastname=$lastname;
    }
    
    public function getCourse(){
        return $this->course;
    }
    public function setCourse($course){
        $this->course=$course;
    }
    
    public function getYear(){
        return $this->year;
    }
    public function setYear($year){
        $this->year=$year;
    }
}

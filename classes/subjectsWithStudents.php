<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class subjectsWithStudents {
    
    private $coursenumber, $descriptivetitle, $term, $numberofStudents;
    
    
    //subjectsWithStudents constructors
    public function __construct($coursenumber, $descriptivetitle, $term, $numberofStudents) {
        $this->coursenumber = $coursenumber;
        $this->descriptivetitle = $descriptivetitle;
        $this->term = $term;
        $this->numberofStudents = $numberofStudents;
    }
    
    
    //getter and setter methods
    public function getCourseNumber (){
        return $this->coursenumber;
    }
    
    public function setCourseNumber($coursenumber){
        $this->coursenumber = $coursenumber;
    }
    
    public function getDescriptiveTitle (){
        return $this->descriptivetitile;
    }
    
    public function setDescriptiveTitle($descriptivetitle){
        $this->descriptivetitle = $descriptivetitle;
    }
    
    public function getTerm (){
        return $this->term;
    }
    
    public function setTerm($term){
        $this->term = $term;
    }
    
    public function getNumberOfStudents (){
        return $this->numberofStudents;
    }
    
    public function setNumberOfStudents($numberofStudents){
        $this->numberofStudents = $numberofStudents;
    }
}
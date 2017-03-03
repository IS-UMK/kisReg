<?php
namespace kisRegBundle\Helpers;

class MiscSorter{
    private $elems;
    public function __construct(){
        $this->elems = [];
    }
    public function add($element){
        if (is_array($element) || ($element instanceof \ArrayAccess && $element instanceof \Traversable)) {
            foreach ($element as $e) {
                $this->elems [] = $e;
            }
        }
        else {
            $this->elems[] = $element;
        }
    }
    public function sort(){
        usort($this->elems,function($a,$b){
            $time_a = 0;
            $time_b = 0;

            if(isset($a))
                try {
                    $time_a = $a->getAbsoluteTime();
                } catch (Exception $e) {}
            if(isset($b))
                try {
                    $time_b = $b->getAbsoluteTime();
                } catch (Exception $e) {}
            return $time_b - $time_a;
        });
    }
    public function removeDuplicates(){
        $dels = [];
        $ids  = [];
        foreach ($this->elems as $index => $e) {
            if(!method_exists($e,'getId')){
                $dels [] = $index;
                continue;
            }
            $id = get_class($e).'/'.$e->getId();
            if(in_array($id,$ids)){
                $dels [] = $index;
            } else {
                $ids [] = $id;
            }
        }
        foreach ($dels as $key)
            unset($this->elems[$key]);
    }
    public function get(){
        return $this->elems;
    }
    public function getSorted(){
        $this->sort();
        $this->removeDuplicates();
        return $this->get();
    }
}

<?php

namespace kisRegBundle\Repository;

/**
 * ZajeciaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ZajeciaRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllGroupedByName(){
        $em = $this->getEntityManager();
        $all = $em->createQuery('SELECT z FROM kisRegBundle:Zajecia z ORDER BY z.poczatek')->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $all = array_map(function($e){
            $o = $this->find($e['id']);
            $e['ids'] = array($e['id']);
            $e['poczatek'] = array($e['poczatek']);
            $e['koniec'] = array($e['koniec']);
            $e['limitMiejsc'] = array($e['limitMiejsc']);
            $e['pozostaloMiejsc'] = array($o->pozostaloMiejsc());
            return $e;
        },$all);
        $out = array();
        for($i=0;$i<count($all);$i++){
            if($all[$i]==null)
                continue;
            for($j=$i+1;$j<count($all);$j++){
                if($all[$i]['nazwa'] == $all[$j]['nazwa']){
                    $all[$i]['ids'][] = $all[$j]['ids'][0];
                    $all[$i]['pozostaloMiejsc'][] = $all[$j]['pozostaloMiejsc'][0];
                    $all[$i]['poczatek'][] = $all[$j]['poczatek'][0];
                    $all[$i]['koniec'][] = $all[$j]['koniec'][0];
                    $all[$i]['limitMiejsc'][] = $all[$j]['limitMiejsc'][0];
                    $all[$j] = null;
                }
            }
            $out[] = $all[$i];
        }
        return $out;
    }
}

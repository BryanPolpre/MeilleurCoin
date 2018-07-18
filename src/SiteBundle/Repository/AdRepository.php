<?php

namespace SiteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AdRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdRepository extends EntityRepository
{

    public function findAll()
    {
        return $this->findBy(array(), array('title' => 'ASC'));
    }

    public function getAdByParam($param)
    {
        $qb = $this->createQueryBuilder('adsearch');

        $qb->select('ad')
            ->from('SiteBundle:Ad', 'ad')
            ->join('ad.category', 'cat')
            ->orderBy('ad.title', 'ASC');

        $i=1;
        foreach ($param as $key => $value) {
            if(!empty($value)) {
                if ($key == "title") {
                    $qb
                        ->andWhere($key . ' LIKE ?' . $i)
                        ->setParameter(2, '%' . addcslashes($value, '%_') . '%');
                } else {
                    $qb
                        ->andWhere($key . ' = ?' . $i)
                        ->setParameter($i, $value);
                }

                $i++;
            }
        }
        return $qb->getQuery()->getResult();
    }

}

<?php

namespace HOSparePartBundle\Repository;

/**
 * SparePartTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SparePartTypeRepository extends \Doctrine\ORM\EntityRepository
{

	public function findCountAllNotUsed($typeId){
		$qb = $this->createQueryBuilder('t');
		$qb->select('count(t)');
		$qb->innerJoin('t.spareParts', 's', 'WITH', 's.type = :type');
		$qb->where('s.isUsed = false');
		$qb->setParameter('type',$typeId);

		return $qb->getQuery()->getSingleScalarResult();
	}
}

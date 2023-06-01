<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Twilio\Rest\Client;


/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    public function save(Reclamation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reclamation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByidreclamation ($value){
        $query=$this->createQueryBuilder('c')
                     ->Where( 'c.id LIKE :value')
                   ->setParameter('value', $value)
                    ->getQuery();
        return $query->getResult();
     }
     public function search($nom) {
         $qb=  $this->createQueryBuilder('s')
             ->where('s.nom_client LIKE :x')
             ->setParameter('x',$nom);
         return $qb->getQuery()
             ->getResult();
     }
 
 
 
     public function countByDate()
     {
         $query=$this->createQueryBuilder('c');
         $query
                 ->select('SUBSTRING(c.description,1,10) as datereclamation , COUNT(c) as count')
                 ->groupBy('datereclamation');
                 return $query->getQuery()->getResult();
 
 
     }
 
     public  function sms(){
         // Your Account SID and Auth Token from twilio.com/console
                 $sid = 'AC9760881e13cbcf16daf43b3ff689c956';
                 $auth_token = 'eca9d423cd3bc59a2b5189080abbf65e';
         // In production, these should be environment variables. E.g.:
         // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
         // A Twilio number you own with SMS capabilities
                 $twilio_number = "+15675571074";
         
                 $client = new Client($sid, $auth_token);
                 $client->messages->create(
                 // the number you'd like to send the message to
                     '+21629571782                     ',
                     [
                         // A Twilio phone number you purchased at twilio.com/console
                         'from' => '+15675571074',
                         // the body of the text message you'd like to send
                         'body' => 'votre reclamation a été confirmé , merci de nous contacter pour plus de détails!'
                     ]
                 );
             }
 
             public function Triepardate(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.description', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Reclamation[] Returns an array of Reclamation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reclamation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

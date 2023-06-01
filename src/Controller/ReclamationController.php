<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;
use App\Form\SearchCType;
use Dompdf\Options;
use Dompdf\Dompdf;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Bundle\PaginatorBundle\Twig\Extension\PaginationExtension;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/reclamation', methods: ['GET', 'POST'])]
class ReclamationController extends AbstractController
{   #[Route('/stats',name:'app_reclamation_stat')]
    public function stats(ReclamationRepository $repository,NormalizerInterface $Normalizer)
    {
        $reclamations=$repository->countByDate();
        $dates=[];
        $reclamationsCount=[];
        foreach($reclamations as $reclamation){
            $dates[] = $reclamation['datereclamation'];
            $reclamationsCount[] = $reclamation['count'];
        }
        dump($reclamationsCount);
        return $this->render('reclamation/stats.html.twig',[
            'dates' => json_encode($dates),
            'reclamationsCount' => json_encode($reclamationsCount),

        ]);
    }

    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('q');
        $reclamations=$reclamationRepository->findAll(); 
        $pagination = $paginator->paginate($reclamations,$request->query->getInt('page',1),2);
        $formSearch= $this->createForm(SearchCType::class); 
    $formSearch->handleRequest($request);
      if($formSearch->isSubmitted()){
        $nom= $formSearch->get('NomClient')->getData();
        $result= $reclamationRepository->search($nom);     // recherche
        return $this->renderForm('admin/Reclamation.html.twig',
            array('reclamations'=>$result,
              
                "searchForm"=>$formSearch));
                
    }
   
 return $this->renderForm('admin/Reclamation.html.twig', [
     'reclamations' => $pagination,  "searchForm"=>$formSearch]);

    
    {
        return $this->render('reclamation/listp.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
}

#[Route('/trie', name: 'trie' )]
public function trie(ReclamationRepository $reclamationRepository ,Request $request,PaginatorInterface $paginator)
{
    $query = $request->query->get('q');
    $reclamations=$reclamationRepository->Triepardate(); 
    $pagination = $paginator->paginate($reclamations,$request->query->getInt('page',1),2);
    $formSearch= $this->createForm(SearchCType::class); 
$formSearch->handleRequest($request);
  if($formSearch->isSubmitted()){
    $nom= $formSearch->get('NomClient')->getData();
    $result= $reclamationRepository->search($nom);     // recherche
    return $this->renderForm('admin/Reclamation.html.twig',
        array('reclamations'=>$result,
          
            "searchForm"=>$formSearch));
            
}

return $this->renderForm('admin/Reclamation.html.twig', [
 'reclamations' => $pagination,  "searchForm"=>$formSearch
]);


{
    return $this->render('admin/Reclamation.html.twig', [
        'reclamations' => $reclamationRepository->findAll(),
    ]);
}
}
#[Route('/calendar', name: 'app_calendar')]
public function index2(ReclamationRepository $repository): Response
{
    $activiters= $repository->findAll();
    $emploit=[];
    foreach ($activiters as $activ){
        $emploit[]=[
            'id'=>$activ->getId(),
            'title'=> $activ->getNomClient(),
            'description'=> $activ->$this->getDescription()(),
            'etat'=> $activ->getEtat(),
            'backgroundColor'=>$this->getRandomColor()
        ];
    }
    $data=json_encode($emploit);




    return $this->render('calendar/Calendar.html.twig',array("data"=>$data));
}


public function generateICalendarFile(ReclamationRepository $repository)
{
    
    $activiters = $repository->findAll();

    $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\n";
    $i=0;
    foreach ($activiters as $activ)
    {
        $i=$i+1;
        $id = $activ->getId();
        $titre = $activ->getNomClient();
        $description = $activ->$this->getDescription()();
        $etat = $activ->getEtat();
        $ics .= "Activiter num :".$i."\r\n";
        $ics .= "Description:" . $description . "\r\n";
        $ics .= "Etat:" . $etat . "\r\n";
        $ics .= "UID:" . $id . "\r\n";
        $ics .= "SUMMARY:" . $titre . "\r\n";
        $ics .= "END:VEVENT\r\n";
    }


    $response = new Response($ics);
    $response->headers->set('bienvenue', 'Calendrier');


    return $response;
}


public function downloadCalendar(ReclamationRepository $repository)
{
    $response = $this->generateICalendarFile($repository);

    return $response;
}




private function getRandomColor()
{
    // Generate random values for the red, green, and blue components
    $r = mt_rand(100, 255);
    $g = mt_rand(100, 255);
    $b = mt_rand(100, 255);

    // Combine the red, green, and blue components into a hexadecimal color string
    $color = "#" . dechex($r) . dechex($g) . dechex($b);

    return $color;
}
    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    public function remove(Reclamation $reclamation, bool $flush = false)
    {
    $this->_em->remove($reclamation);
    if ($flush) {
        $this->_em->flush();
    }
    }
    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository , EntityManagerInterface $entityManager ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation, true);
            $entityManager->flush();
        }
        dump($reclamation);


        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/reclamation/data/download', name: 'users_data_download')]

    public function usersDataDownload(ReclamationRepository $reclamation)
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
    
        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $reclamation= $reclamation->findAll();
       
        // $classrooms= $this->getDoctrine()->getRepository(classroomRepository::class)->findAll();
    
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);
    
        // On génère le html
        $html =$this->renderView('reclamation/listp.html.twig',[
            'reclamations'=>$reclamation
        ]);
    
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // On génère un nom de fichier
        $fichier = 'Liste-reclamation' .'.pdf';
    
        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);
    
        return new Response() ;
    }

}

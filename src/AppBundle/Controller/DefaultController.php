<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Destination;
use AppBundle\Form\DestinationType;

use AppBundle\Entity\City;
use AppBundle\Form\CityType;

use AppBundle\Entity\Circuit;
use AppBundle\Form\CircuitType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Proxies\__CG__\AppBundle\Entity\City as ProxiesCity;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function homeAction()

    {
        $texte = 'Choisissez les meilleurs circuits pour vos plus beaux voyages';

        return $this->render('twig_pages/home.html.twig',
            [
                'texte' => $texte,
            ]
        );
    }

    /**
     * @Route("/admin", name="admin_home")
     */
    public function adminHomeAction()

    {
        return $this->render('twig_pages/admin_home.html.twig',
            [

            ]
        );
    }




    /**
     * @Route ("/admin/form/create/destination", name="form_create_destination")
     */

    public function formCreateDestinationAction(Request $request)
    {
        // Equivalent de passer la variable $request en parametre de
        // la méthode formCreateDestinationAction.
        // la méthode createFromGlobals vient prendre les données
        // de $_POST, $_GET et les regroupe.
        //$request = Request::createFromGlobals();
        $destination = new Destination();

        // création du gabarit de formulaire en utilisant la classe BookType
        // générée par la ligne de commande generate:doctrine:form AppBundle:Book
        $destinationForm = $this->createForm(DestinationType::class, $destination);

        // utilisation du gabarit de formulaire pour créer une vue du formulaire
        // à envoyer dans le fichier twig
        $formCreateDestination = $destinationForm->createView();

        // je récupère la variable $request, qui contient les données de la requête
        // et notamment les données de $_POST
        $destinationForm->handleRequest($request);
        // je récupère ma variable $bookForm, qui contient désormais
        // mon formulaire avec les données de ma requête,
        // et je vérifie que des données ont bien été envoyées et
        // qu'elles sont valides par rapport à ce que demande
        // l'entité Destination
        if  ($destinationForm->isSubmitted() && $destinationForm->isValid()) {
            // j'enregistre ma destination en base de données.
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($destination);
            $entityManager->flush();

            return $this->redirectToRoute('amdin_destination');
        }

        return $this->render('twig_pages/destination_create.html.twig',
            [
                'formCreateDestination' => $formCreateDestination
            ]
        );
    }

    /**
     * @Route ("/admin/destination", name="admin_destination")
     */
    public function adminDestinationAction()
    {

        $destination = $this->getDoctrine()
            ->getRepository(Destination::class)
            ->findAll();
        return $this->render('twig_pages/admin_destination.html.twig',
            [
                'destination' => $destination
            ]
        );
    }

    /**
     * @Route ("/admin/form/create/city", name="form_create_city")
     */

    public function formCreateCityAction(Request $request)
    {
        
        $city = new City();

        
        $cityForm = $this->createForm(CityType::class, $city);

        
        $formCreateCity = $cityForm->createView();

        
        $cityForm->handleRequest($request);
        
        if  ($cityForm->isSubmitted() && $cityForm->isValid()) {

            $file = $city->getImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            try {
                $file->move($this->getParameter('city_directory'), $fileName);

            } catch (FileException $e) {

                return $this->redirectToRoute('error');
            }

            $city->setImage($fileName);

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('admin_city');
        }

        return $this->render('twig_pages/city_create.html.twig',
            [
                'formCreateCity' => $formCreateCity
            ]
        );
    }

    /**
     * @Route ("/admin/city", name="admin_city")
     */
    public function adminCityAction()
    {
        $cities = $this->getDoctrine()
            ->getRepository(City::class)
            ->findAll();

        return $this->render('twig_pages/admin_city.html.twig',
            [
                'cities' => $cities
            ]
        );
    }

    /**
     * @Route("/admin/city/delete/{id}", name="delete_city")
     */
    public function cityDeleteAction($id)
    {
        $cityRepository = $this->getDoctrine()->getRepository(City::class);
        $city = $cityRepository->find($id);

        $circuitRepository = $this->getDoctrine()->getRepository(Circuit::class);
        $circuits = $circuitRepository->findBy(['cities' => $city]);

        $entityManager = $this->getDoctrine()->getManager();

        foreach ($circuits as $circuit)
        {
            $entityManager->remove($circuit);
        }

        $entityManager->remove($city);
        $entityManager->flush();

        return $this->render('twig_pages/delete_city.html.twig',
            [
                'cityRepository' => $cityRepository,
                'city' => $city,

                'circuitRepository' => $circuitRepository,
                'circuits' => $circuits
            ]
        );
    }

   /**
     * @Route ("/admin/update/form/city/{id}", name="update_form_city")
     */
    public function updateFormCityAction(Request $request, $id)
    {
        $cityUpdate = $this->getDoctrine()
            ->getRepository(City::class);

        $city = $cityUpdate->find($id);

        $imgSave = $city->getImage();
        $city->setImage(null);
        
        $cityForm = $this->createForm(CityType::class, $city);

        $cityFormCreate = $cityForm->createView();

        $cityForm->handleRequest($request);

        if  ($cityForm->isSubmitted() && $cityForm->isValid()) {
            if($city->getImage() === null){
                $city->setImage($imgSave);
            }
            else{
                //je récupère l'image uploader par l'utilisateur
                $file = $city->getImage();
                // je génère un nom unique suivie de l'extension
                $fileName = md5(uniqid().'.'.$file->guessExtension());

                try {
                    $file->move (
                        $this->getParameter('city_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                    throw new \Exception(($e->getMessage()));
                }
            }

            $city = $cityForm->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute("admin_city");
        }

        return $this->render('twig_pages/city_create.html.twig',
            [
                'formCreateCity' => $cityFormCreate
            ]
        );
    }

    /**
     * @Route ("/city", name="city")
     */
    public function cityAction()
    {
        $cities = $this->getDoctrine()
            ->getRepository(City::class)
            ->findAll();
        
        return $this->render('twig_pages/city.html.twig',
            [
                'texte' => 'Choisissez une ville',
                'cities' => $cities
            ]
        );
    }

    /**
     * @Route ("/admin/form/create/circuit", name="form_create_circuit")
     */

    public function formCreateCircuitAction(Request $request)
    {
        
        $circuit = new Circuit();

        
        $circuitForm = $this->createForm(CircuitType::class, $circuit);

        
        $formCreateCircuit = $circuitForm->createView();

        
        $circuitForm->handleRequest($request);
        
        if  ($circuitForm->isSubmitted() && $circuitForm->isValid()) {
            
            $file = $circuit->getDocument();

            $fileName = md5(uniqid().'.'.$file->guessExtension());

            try {
                $file->move($this->getParameter('document_directory'), $fileName);

            } catch (FileException $e) {

                return $this->redirectToRoute('error');
            }

            $circuit->setDocument($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($circuit);
            $entityManager->flush();

            return $this->redirectToRoute("admin_circuit");
        }

        return $this->render('twig_pages/circuit_create.html.twig',
            [
                'formCreateCircuit' => $formCreateCircuit
            ]
        );
    }

    /**
     * @Route ("/admin/circuit/{id}", name="admin_circuit", defaults={"id": ""})
     */
    public function adminCircuitAction($id)
    {
        if($id != null)
        {
            $circuits = $this->getDoctrine()
            ->getRepository(Circuit::class)
            ->find($id);
            
        } else {

            $circuits = $this->getDoctrine()
            ->getRepository(Circuit::class)
            ->findAll();

        }
        
        return $this->render('twig_pages/admin_circuit.html.twig',
            [
                'circuits' => $circuits
            ]
        );
    }

    /**
     * @Route ("/circuit/{id}", name="circuit")
     */
    public function circuitAction($id)
    {
        $circuits = $this->getDoctrine()
            ->getRepository(Circuit::class)
            ->findBy(['cities' => $id]);

        return $this->render('twig_pages/circuit.html.twig',
            [
                'texte' => 'Choisissez votre circuit',
                'circuits' => $circuits
            ]
        );
    }

    /**
     * @Route ("/admin/update/form/circuit/{id}", name="update_form_circuit")
     */
    public function updateFormCircuitAction(Request $request, $id)
    {
        $circuitUpdate = $this->getDoctrine()
            ->getRepository(Circuit::class);

        $circuit = $circuitUpdate->find($id);
        
        $circuitForm = $this->createForm(CircuitType::class, $circuit);

        $circuitFormCreate = $circuitForm->createView();

        $circuitForm->handleRequest($request);

        if  ($circuitForm->isSubmitted() && $circuitForm->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($circuit);
            $entityManager->flush();

            return $this->redirectToRoute("admin_circuit");

        }

        return $this->render('twig_pages/circuit_create.html.twig',
            [
                'formCreateCircuit' => $circuitFormCreate
            ]
        );
    }

    /**
     * @Route("/admin/circuit/delete/{id}", name="delete_circuit")
     */
    public function circuitDeleteAction($id)
    {
        $circuitRepository = $this->getDoctrine()->getRepository(Circuit::class);
        $circuit = $circuitRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($circuit);
        $entityManager->flush();

        return $this->render('twig_pages/delete_circuit.html.twig',
            [
                'circuitRepository' => $circuitRepository,
                'circuit' => $circuit
            ]
        );
    }

     /**
     * @Route ("/admin/error", name="error")
     */
    public function errorAction()
    {
        return $this->render('twig_pages/error.html.twig');
    }

    // ENVOIE MAIL
    private function sendRouteMail($mailUser,$ledoc){
        $ContactMail = 'clementraoul97@gmail.com';
        $ContactPassword = 'biroule85';

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($ContactMail)
            ->setPassword($ContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Votre feuille de route InsideCity")
            ->setFrom([$ContactMail => "Message par ".$ContactMail])
            ->setTo([ $mailUser ])
            ->setBody("Bonjour, merci d'avoir fait confiance à Inside City pour votre prochain voyage. Voici le circuit que vous avez choisit. À bientôt. Inside City")
            ->attach(\Swift_Attachment::fromPath('/Applications/MAMP/htdocs/inside_city_symfony/web/assets/document/'.$ledoc));

        return $mailer->send($message);
    }

    /**
     * @Route("/envoieMessage/{ledoc}", name="envoieMessage")
     */
    public function envoieMessageAction($ledoc)
    {


        $user = $this->getUser();

        $mailUser = $user->getEmail();

        $this->sendRouteMail($mailUser, $ledoc);

        return $this->render('twig_pages/good_send.html.twig',
            [
               
            ]
        );

    }
}
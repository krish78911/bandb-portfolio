<?php

namespace App\Controller;
use App\Entity\Rooms;
use App\Entity\Bookings;
use App\Form\SearchType;
use App\Form\BookType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request)
    {
        $em = $this->getDoctrine()->getManager();      
        $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findAll();

        $form = $this->createForm(SearchType::class);
        $form->add('create', SubmitType::class, array('label' => 'SEARCH'));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('search');

            $this->setAvailability($rooms, $data['from'], $data['to']);

            $nights = $this->calculateNumberOfDays($data['from'], $data['to']);

            return $this->render('home.html.twig', [
                'rooms'             => $rooms,
                'fromdate'          => $data['from'],
                'todate'            => $data['to'],
                'nights'            => $nights,
                'numberofpersons'   => 1,
                'searchform'        => $form->createView(),
            ]);
        }

        $this->setAvailability($rooms, date("Y-m-d"), date("Y-m-d", strtotime("+1 day")));

        return $this->render('home.html.twig', [
            'rooms'             => $rooms,
            'fromdate'          => date("Y-m-d"),
            'todate'            => date("Y-m-d", strtotime("+1 day")),
            'nights'            => 1,
            'numberofpersons'   => 1,
            'searchform'        => $form->createView(),
        ]);
    }

    public function calculateNumberOfDays($from, $to) {
        $datetime1 = date_create($from);
        $datetime2 = date_create($to);
        return date_diff($datetime1, $datetime2)->format('%d');

    }

    public function setAvailability($rooms, $from, $to) {

        $manager = $this->getDoctrine()->getManager();
        $conn = $manager->getConnection();
        $bookings= $conn->query('SELECT * FROM `bookings` WHERE "'.$from.'" between datefrom and dateto
                                        OR "'.$to.'" between datefrom and dateto
                                    ')->fetchAll();

        if (empty($bookings)) {
            foreach ($rooms as $roomKey => $roomValue) {
                $rooms[$roomKey]->setAvailability(0);
            }
        }
        else {
            foreach ($rooms as $roomKey => $roomValue) {
                foreach ($bookings as $booking) {
                    
                    if ($booking['roomid'] == $roomValue->getId()) {
                        $rooms[$roomKey]->setAvailability(1);
                    } 
                }
            }
        }
    }


    /**
     * @Route("/detail/{id}/{from}/{to}", name="detail")
     */
    public function detail(Request $request, $id, $from, $to)
    {
        //get all images from folder
        $images = array();
        $all_files = glob($this->getParameter('kernel.project_dir').'/public/images/rooms/double/*.*');
        for ($i=0; $i<count($all_files); $i++) {
            {
            $image_name = $all_files[$i];
            
            $supported_format = array('gif','jpg','jpeg','png');
            $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                if (in_array($ext, $supported_format)) {
                    array_push($images, basename($image_name));
                } else {
                    continue;
                }
            }
        }

        $em = $this->getDoctrine()->getManager();     
        $conn = $em->getConnection();
        $bookings= $conn->query('SELECT * FROM `bookings` WHERE roomid='.$id.' AND ("'.$from.'" between datefrom and dateto
                                        OR "'.$to.'" between datefrom and dateto)
                                    ')->fetchAll();

        if(!empty($bookings)) {
            return $this->redirectToRoute('home');
        }

                                    
        $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findBy(array('id' => $id));

        if(empty($rooms)) {
            return $this->redirectToRoute('home');
        }

        $choices = array('persons' => '');
        for($i=1; $i<=$rooms[0]->getMaxpeople(); $i++) {
            $choices += array($i => $i);
        }
        $form = $this->createForm(BookType::class);
        $form->add('numberofpeople', ChoiceType::class,
        [ 'choices'  => $choices] );
        $form->add('create', SubmitType::class, array('label' => 'BOOK'));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('book');
            $booking = new Bookings();

            $booking->setRoomid($data['roomid']);
            $booking->setDatefrom($data['datefrom']);
            $booking->setDateto($data['dateto']);
            $booking->setFirstname($data['firstname']);
            $booking->setLastname($data['lastname']);
            $booking->setEmail($data['email']);
            $booking->setPhone($data['phone']);
            $booking->setNumberofpeople($data['numberofpeople']);

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($booking);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

        }
        $nights = $this->calculateNumberOfDays($from, $to);

        return $this->render('detail.html.twig', [
            'roomid'            => $id,
            'rooms'             => $rooms,
            'fromdate'          => $from,
            'todate'            => $to,
            'nights'            => $nights,
            'numberofpersons'   => 1,
            'bookform'          => $form->createView(),
            'images'           => $images,
        ]);
    }
}
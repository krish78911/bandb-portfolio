<?php

namespace App\Controller;
use App\Entity\Rooms;
use App\Entity\Bookings;
use App\Form\RoomType;
use App\Form\EditRoomType;
use App\Form\EditBookType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $bookings= $conn->query('select bookings.*, rooms.roomtype from bookings INNER JOIN rooms ON rooms.id = bookings.roomid')->fetchAll();

        $editform = $this->createForm(EditBookType::class);
        $editform->add('edit', SubmitType::class, [
            'attr' => ['class' => 'editBookingButton'],
        ]);

        $record = $em->getRepository(Bookings::class)->find(44);

        $editform->handleRequest($request);
        if ($editform->isSubmitted() && $editform->isValid()) {
            $data = $request->request->get('edit_book');
            $record = $em->getRepository(Bookings::class)->find($data['id']);
            if (!$record) {
                return new Response('No record found for id '.$data['id']);
            }
            $record->setRoomid($data['roomid']);
            $record->setDatefrom($data['datefrom']);
            $record->setDateto($data['dateto']);
            $record->setFirstname($data['firstname']);
            $record->setLastname($data['lastname']);
            $record->setEmail($data['email']);
            $record->setPhone($data['phone']);
            $record->setNumberofpeople($data['numberofpeople']);

            $em->persist($record);
            $em->flush();
            
            $bookings = $conn->query('select bookings.*, rooms.roomtype from bookings INNER JOIN rooms ON rooms.id = bookings.roomid')->fetchAll();

            return $this->render('admin/bookings.html.twig', [
                'bookings' => $bookings,
                'editform' => $editform,
            ]);
        }

        return $this->render('admin/adminbookings.html.twig', [
            'bookings' => $bookings,
            'editform' => $editform,
        ]);
    }

    /**
     * @Route("/managerooms", name="managerooms")
     */
    public function managerooms(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findAll();

        $form = $this->createForm(RoomType::class);
        $form->add('create', SubmitType::class, array('label' => 'ADD'));

        $editform = $this->createForm(EditRoomType::class);
        $editform->add('edit', SubmitType::class, [
            'attr' => ['class' => 'editRoomButton'],
        ]);

        $editform->handleRequest($request);
        if ($editform->isSubmitted() && $editform->isValid()) {
            $data = $request->request->get('edit_room');
            $record = $em->getRepository(Rooms::class)->find($data['id']);
            if (!$record) {
                return new Response('No record found for id '.$data['id']);
            }
            $record->setRoomtype($data['roomtype']);
            $record->setMaxpeople($data['maxpeople']);
            $record->setPrice($data['price']);
            $record->setAvailability($data['availability']);
            $record->setCheckin($data['checkin']);
            $record->setCheckout($data['checkout']);
            $record->setPrivatebathroom($data['privatebathroom']);
            $record->setDescription($data['description']);

            $em->persist($record);
            $em->flush();
            $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findAll();
            return $this->render('admin/rooms.html.twig', [
                'rooms' => $rooms,
                'editform' => $editform,
            ]);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('room');
            $rooms = new Rooms();

            $rooms->setRoomtype($data['roomtype']);
            $rooms->setMaxpeople($data['maxpeople']);
            $rooms->setPrice($data['price']);
            $rooms->setAvailability($data['availability']);
            $rooms->setCheckin($data['checkin']);
            $rooms->setCheckout($data['checkout']);
            $rooms->setPrivatebathroom($data['privatebathroom']);
            $rooms->setDescription($data['description']);
            
            $em->persist($rooms);
            $em->flush();

            $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findAll();
            return $this->render('admin/rooms.html.twig', [
                'rooms' => $rooms,
                'editform' => $editform,
            ]);
        }

        return $this->render('admin/adminrooms.html.twig', [
            'rooms' => $rooms,
            'addroomform' => $form->createView(),
            'editform' => $editform,
        ]);
    }

    /**
     * @Route("/deletebooking/{id}", name="deletebooking")
     */
    public function deletebooking(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository(Bookings::class)->find($id);
        if (!$record) {
            throw $this->createNotFoundException(
                'No candidate found for id '.$id
            );
        }
        
        $em->remove($record);
        $em->flush();
        
        $conn = $em->getConnection();
        $bookings= $conn->query('select bookings.*, rooms.roomtype from bookings INNER JOIN rooms ON rooms.id = bookings.roomid')->fetchAll();

        $editform = $this->createForm(EditBookType::class);
        $editform->add('edit', SubmitType::class, [
            'attr' => ['class' => 'editBookingButton'],
        ]);

        return $this->render('admin/bookings.html.twig', [
            'bookings' => $bookings,
            'editform' => $editform,
        ]);

    }

    /**
     * @Route("/deleteroom/{id}", name="deleteroom")
     */
    public function deleteroom(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $record = $em->getRepository(Rooms::class)->find($id);
        if (!$record) {
            throw $this->createNotFoundException(
                'No candidate found for id '.$id
            );
        }
        $em->remove($record);
        $em->flush();

        $rooms = $this->getDoctrine()->getRepository(Rooms::class)->findAll();
        $editform = $this->createForm(EditRoomType::class);
        $editform->add('create', SubmitType::class, array('label' => 'EDIT'));

        return $this->render('admin/rooms.html.twig', [
            'rooms' => $rooms,
            'editform' => $editform,
        ]);
    }

}
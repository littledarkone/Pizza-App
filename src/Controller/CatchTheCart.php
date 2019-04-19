<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;        
        
class CatchTheCart extends AbstractController
{
    /**
     * @Route("/catchTheCart", name="catch2") methods={"GET","POST"}
     */
    public function index()
    {
        $request = Request::createFromGlobals(); // the envelope, and were looking inside it.
		
        // catch the variables we sent from the JavaScript.
        $placedbyid = $request->request->get('placedbyId', '0');
		$placedby = $request->request->get('placedby', 'this is the default');
		$ser = $request->request->get('ser', 'this is the default');
		$address = $request->request->get('address', 'this is the default');
		$orderdate = $request->request->get('orderdate', 'this is the default');
		$status = $request->request->get('status', 'this is the default');
		$price = $request->request->get('price', 'this is the default');
        
        // to work the objects
        $entityManager = $this->getDoctrine()->getManager();

        // create blank entity of type "Orders"
        $order = new Orders();
        
		$order->setPlacedbyId($placedbyid);
        $order->setPlacedBy($placedby);
        $order->setDetail(substr($ser, 0, -1));
		$order->setAddress($address);
		$order->setOrderdate($orderdate);
		$order->setStatus($status);
		$order->setPrice($price);
		

        $entityManager->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response(
			'all ok' . $ser
        ); 
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;   

class viewAll extends AbstractController
{	
	
    /**
     * @Route("/viewAll", name="viewall")
     */
    public function index()
    {
		$request = Request::createFromGlobals(); // the envelope, and we're looking inside it.

        $type = $request->request->get('type', 'none'); // to send ourself in different directions
        
        if($type == 'viewDriver'){
			
			$entityManager = $this->getDoctrine()->getManager();     

			$status = $request->request->get('pend', 'none');
     
			$orders = $this->getDoctrine()->getRepository(Orders::class)->findBy(array('status' => $status));
					
			$output = '<table style="width: 100%"> 
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Customer Name</th>
									<th>Item&Quantity</th>
									<th>Address</th>
									<th>Price</th>
									<th>Status</th>
								</tr>	
							</thead>';
       
			foreach($orders as $pro){
           
				$output .= '<tbody>
							<tr>'; // one row
				$output .= '<td>' . $pro->getId() . '</td>';
				
				$output .= '<td>' . $pro->getPlacedby() . '</td>'; // one column
           
				$output .= '<td>'; //next column
				
				$data = explode('=', $pro->getDetail()); // get the raw serialized order, breaking when we see the equals
           
				foreach($data as $record) {    // e.g., pizza-4 one record! 
           
					$item = explode('-',$record); // break it apart based on the dash.
				
				
					if ($item[1] > 0) {
						
						$output .= $item[1]. '   ' . $item[0]. '   ';
						
					}
				}
				$output .= '</td>';
           
				$output .= '<td>' . $pro->getAddress() . '</td>'; // one column 
		   
				$output .= '<td>' . '€' . $pro->getPrice() . '</td>'; // one column
		   
				$output .= '<td>' . $pro->getStatus() . '</td>'; // one column
		   
				$output .= '</tr>';        

		}

		$output .= '</table>';
			

			return new Response(
				$output
			);
        
		}
		if($type == 'viewAll'){
			
			$entityManager = $this->getDoctrine()->getManager();     
     
			$orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();
					
			$output = '<table style="width: 100%"> 
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Customer Name</th>
									<th>Item&Quantity</th>
									<th>Address</th>
									<th>Price</th>
									<th>Status</th>
								</tr>	
							</thead>';
       
			foreach($orders as $pro){
           
				$output .= '<tbody>
							<tr>'; // one row
				$output .= '<td>' . $pro->getId() . '</td>';
				
				$output .= '<td>' . $pro->getPlacedby() . '</td>'; // one column
           
				$output .= '<td>'; //next column
				
				$data = explode('=', $pro->getDetail()); // get the raw serialized order, breaking when we see the equals
           
				foreach($data as $record) {    // e.g., pizza-4 one record! 
           
					$item = explode('-',$record); // break it apart based on the dash.
				
				
					if ($item[1] > 0) {
						
						$output .= $item[1]. '   ' . $item[0]. '   ';
						
					}
				}
				$output .= '</td>';
           
				$output .= '<td>' . $pro->getAddress() . '</td>'; // one column 
		   
				$output .= '<td>' . '€' . $pro->getPrice() . '</td>'; // one column
		   
				$output .= '<td>' . $pro->getStatus() . '</td>'; // one column
		   
				$output .= '</tr>';        

		}

		$output .= '</table>';
			

			return new Response(
				$output
			);
        
		}
	}
}

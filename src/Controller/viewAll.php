<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;   

class viewAll extends AbstractController
{
    /**
     * @Route("/viewAll", name="viewall")
     */
    public function index()
    {
        
        $entityManager = $this->getDoctrine()->getManager();        
     
		$orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();
       
		$output = '<table> 
						<thead>
							<tr>
								<th>Customer Name</th>
								<th>Item</th>
								<th>Quantity</th>
							</tr>
						</thead>';
       
		foreach($orders as $pro){
           
           $output .= '<tbody>
							<tr>'; // one row
           $output .= '<td>' . $pro->getPlacedby() . '</td>'; // one column
           
           // making the column
           $output .= '<td>'; //next column
           $data = explode('=', $pro->getDetails()); // get the raw serialized order, breaking when we see the equals
           
            foreach($data as $record) {    // e.g., pizza-4 one record! 
           

                $item = explode('-',$record); // break it apart based on the dash.
                
                $output .= 'Item: ' . $item[0]. ' ';
                $output .='Qty: ' . $item[1] . ' <br>';
            
            
            
        }
           
           
           
           $output .= '</td>'; // raw serialized data
           
           // add here another column.
           
           $output .= '</tr>';        
           
           
           
        
       }
      
      
      $output .= '</table>';

          return new Response(
            $output
        );
        
    }
}

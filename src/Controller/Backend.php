<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Backend extends AbstractController
{
	private $session;
	
    public function __construct(SessionInterface $session) 
	{
        $this->session = $session;
    }
    /**
     * @Route("/backend", name="catch") methods={"GET","POST"}
     */
    public function index(SessionInterface $session)
    {
        $request = Request::createFromGlobals(); // the envelope, and we're looking inside it.

        $type = $request->request->get('type', 'none'); // to send ourself in different directions
        
        if($type == 'register'){
            // perform register process
            
            // get the variables
            $username = $request->request->get('username', 'none');
            $password = $request->request->get('password', 'none');
			$email    = $request->request->get('email', 'none');
            $acctype  = $request->request->get('acctype', 'none');
                        
            // put in the database            
            $entityManager = $this->getDoctrine()->getManager();

              $registerUser = new Login();
              $registerUser->setUsername($username);
              $registerUser->setPassword($password);
			  $registerUser->setEmail($email);
              $registerUser->setAcctype($acctype);
			  $registerUser->setStatus("Active");
             
			$entityManager->persist($registerUser);

             // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
			
			$repo = $this->getDoctrine()->getRepository(Login::class);
            $findOne = $repo->findOneBy([
                 'username' => $username,
                 'password' => $password
             ]);      
             
             $session->set('userid', $findOne->getID());
             $session->set('username', $username);
                        
             return new Response(
                    $registerUser->getAcctype()
                    );
        }
        else if($type == 'login'){ // if we had a login
            
            // get the username and password
            $username = $request->request->get('username', 'none');
            $password = $request->request->get('password', 'none');
            
            $repo = $this->getDoctrine()->getRepository(Login::class); // the type of the entity
            
            $findOne = $repo->findOneBy([
                'username' => $username,
                'password' => $password,
                ]);
				
				$session->set('username', $username);
				$session->set('userid', $findOne->getID());

                return new Response(
                    $findOne->getAcctype()
                    );                  
        }  
		else if($type == 'getusername'){
            // send back a response, with the username we stored in the session.
            return new Response($session->get('username'));
		}
		else if($type == 'getuserid'){
            // send back a response, with the username we stored in the session.
            return new Response($session->get('userid'));
		}
    }
    
    
}
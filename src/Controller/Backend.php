<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Login;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;   

class Backend extends AbstractController
{
    /**
     * @Route("/backend", name="catch") methods={"GET","POST"}
     */
    public function index()
    {
        $request = Request::createFromGlobals(); // the envelope, and we're looking inside it.

        $type = $request->request->get('type', 'none'); // to send ourself in different directions
        
        if($type == 'register'){
            // perform register process
            
            // get the variables
            $username = $request->request->get('username', 'none');
            $password = $request->request->get('password', 'none');
            $acctype = $request->request->get('acctype', 'none');
                        
            // put in the database            
             $entityManager = $this->getDoctrine()->getManager();

              $login = new Login();
              $login->setUsername($username);
              $login->setPassword($password);
              $login->setAcctype($acctype);
             
             $entityManager->persist($login);

             // actually executes the queries (i.e. the INSERT query)
             $entityManager->flush();             
                        
             return new Response(
                    $login->getAcctype()
                    );
            
        }
        else if($type == 'login'){ // if we had a login
            
            // get the username and password
            $username = $request->request->get('username', 'none');
            $password = $request->request->get('password', 'none');
            
            $repo = $this->getDoctrine()->getRepository(Login::class); // the type of the entity
            
            $person = $repo->findOneBy([
                'username' => $username,
                'password' => $password,
                ]);

                return new Response(
                    $person->getAcctype()
                    );                  
        }    
    }
    
    
}
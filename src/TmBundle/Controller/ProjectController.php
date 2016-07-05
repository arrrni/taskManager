<?php

namespace TmBundle\Controller;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;

use TmBundle\Form\Type\ProjectType;
use TmBundle\Entity\Project;

class ProjectController extends Controller {
    /**
     * @Route("add_project", name="add_project_tm")
     * @param Request $request
     * @return Response
     * @Template()
     */
    public function addProjectAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();

                return $this->redirectToRoute('task_page_tm');
            }
            else {
                return array(
                    'form' => $form->createView()
                );
            }
        }
        return array(
            'form' => $form->createView()
        );
    }
}
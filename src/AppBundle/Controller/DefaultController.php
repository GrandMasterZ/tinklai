<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Problem;
use AppBundle\Entity\Report;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        if($user == null)
        {
            return $this->redirect('/login');
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(

        ));
    }

    /**
     * @Route("/newProblem", name="newProblem")
     */
    public function addProblemAction(Request $request)
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository('AppBundle:State');
        $state = $repository->find(1);

        if($user == null)
        {
            return $this->redirect('/login');
        }

        $problem = new Problem();
        $problem->setTimeCreated(new \DateTime());
        $problem->setState($state);
        $problem->setCreator($user);

        $form = $this->createFormBuilder($problem)
            ->add('hardware_name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('ip', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Sukurti problemą'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $problem = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($problem);
            $em->flush();

            return $this->redirect('/createdProblems');
        }

        return $this->render('default/newProblem.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/problems", name="problemList")
     */
    public function viewProblems(Request $request)
    {
        $user = $this->getUser();

        if($user == null)
        {
            return $this->redirect('/login');
        }

        $repository = $this->getDoctrine()->getRepository('AppBundle:Problem');

        $query = $repository->createQueryBuilder('p')
            ->where('p.state = 1')
            ->getQuery();

        $problems = $query->getResult();

        //$problems = $repository->findAll();
        // replace this example code with whatever you need
        return $this->render('default/problems.html.twig', array(
            'problems' => $problems,
        ));
    }

    /**
     * @Route("/createdProblems", name="createdProblemList")
     */
    public function viewCreatedProblems(Request $request)
    {
        $user = $this->getUser();

        if($user == null)
        {
            return $this->redirect('/login');
        }

        $repository = $this->getDoctrine()->getRepository('AppBundle:Problem');

        $query = $repository->createQueryBuilder('p')
            ->where('p.creator =' . $user->getId())
            ->getQuery();

        $problems = $query->getResult();

        //$problems = $repository->findAll();
        // replace this example code with whatever you need
        return $this->render('default/createdProblems.html.twig', array(
            'problems' => $problems,
        ));
    }

    /**
     * @Route("/currentProblem", name="problem")
     */
    public function viewProblem(Request $request)
    {
        $user = $this->getUser();

        if($user == null)
        {
            return $this->redirect('/login');
        }

        $problem = $user->getProblem();
        // replace this example code with whatever you need
        return $this->render('default/currentProblem.html.twig', array(
            'problem' => $problem,
        ));
    }

    /**
     * @Route("/newReport", name="report")
     */
    public function newReport(Request $request)
    {
        $user = $this->getUser();
        $time = new \DateTime();
        $stateRepository = $this->getDoctrine()->getRepository('AppBundle:State');
        $state = $stateRepository->find(3);

        if($user->getProblem() == null)
        {
            return $this->redirect('/');
        }

        if($user == null)
        {
            return $this->redirect('/login');
        }

        $problem = $user->getProblem();
        $problem->setTimeFixed($time);
        $problem->setState($state);

        $report = new Report();
        $report->setTimeCreated($time);
        $report->setProblem($problem);

        $form = $this->createFormBuilder($report)
            ->add('cause', TextareaType::class)
            ->add('solution', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Pateikti ataskaitą'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setProblem(null);
            $report = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($report);
            $em->flush();

            return $this->render('default/index.html.twig', array(
                'successMessage' => 'Ataskaita sėkmingai išsiųsta',
            ));
        }
        // replace this example code with whatever you need

        // replace this example code with whatever you need
        return $this->render('default/report.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/takeProblem/{problemId}", name="takeProblem")
     */
    public function takeProblem(Request $request)
    {
        if($this->getUser()->getProblem() == null)
        {
            $doctrine = $this->getDoctrine();
            $stateRepository = $doctrine->getRepository('AppBundle:State');
            $problemRepository = $doctrine->getRepository('AppBundle:Problem');

            $state = $stateRepository->find(2);
            $problemId = $request->attributes->get('problemId');
            $em = $doctrine->getManager();
            $problem = $problemRepository->find($problemId);
            $problem->setTimeTaken(new \DateTime());
            $problem->setState($state);
            $user = $this->getUser();
            $user->setProblem($problem);

            $em->flush();
            // replace this example code with whatever you need

            // replace this example code with whatever you need
            return $this->redirect('/currentProblem');
        }

        $error = "Jūs jau turite sprendžiamą problemą";

        return $this->render('default/index.html.twig', array(
            'error' => $error
        ));
    }

    /**
     * @Route("/users", name="userList")
     */
    public function users(Request $request)
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if($user == null || !in_array("ROLE_OPERATOR", $roles))
        {
            return $this->redirect('/login');
        }

        $doctrine = $this->getDoctrine();
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $users = $userRepository->findAll();

        $query = $userRepository->createQueryBuilder('p')
            ->where('p.enabled = 0')
            ->getQuery();

        $disabledUsers = $query->getResult();

        return $this->render('default/users.html.twig', array(
            'users' => $users,
            'disabledUsers' => $disabledUsers
        ));
    }

    /**
     * @Route("/activateUser/{userId}", name="activateUser")
     */
    public function activate(Request $request)
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if($user == null || !in_array("ROLE_OPERATOR", $roles))
        {
            return $this->redirect('/');
        }

        $em = $this->getDoctrine()->getManager();
        $doctrine = $this->getDoctrine();
        $userId = $request->attributes->get('userId');
        $userRepository = $doctrine->getRepository('AppBundle:User');
        $user = $userRepository->find($userId);
        $user->setEnabled(true);
        $em->flush();
        return $this->redirect('/users');
    }

    /**
     * @Route("/reports", name="reports")
     */
    public function report(Request $request)
    {
        $user = $this->getUser();
        $roles = $user->getRoles();

        if($user == null || !in_array("ROLE_MANAGER", $roles))
        {
            return $this->redirect('/');
        }

        $doctrine = $this->getDoctrine();
        $reportRepository = $doctrine->getRepository('AppBundle:Report');
        $reports = $reportRepository->findAll();

        return $this->render('default/reports.html.twig', array(
            'reports' => $reports,
        ));

    }
}

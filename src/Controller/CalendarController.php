<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\PostService;
use App\Service\UsersService;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CalendarController
 * @package App\Controller
 */
class CalendarController extends AbstractController
{

    /**
     * CalendarController constructor.
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function getAction()
    {
    }
}

<?php

namespace Arii\ACKBundle\Controller;
use Arii\ACKBundle\Entity\Alarm;
use Arii\ACKBundle\Form\AlarmType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use JMS\Serializer\SerializerBuilder;

class AlarmsController extends Controller
{
    public function addAction(Request $request)
    {
        // On crée un objet Alarm
        $alarm = new Alarm();
        $form = $this->createForm(AlarmType::class, $alarm);

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AriiACKBundle:Alarms:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function listAction()
    {
        $Alarms = $this->getDoctrine()->getRepository('AriiACKBundle:Alarm')->listAlarms();
        
        $render = $this->container->get('arii_core.render');     
        return $render->grid($Alarms,'id,name,state_time');
    }
    
}

<?php

namespace Arii\ReportBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Arii\ReportBundle\Entity\BKP_REF;
use Arii\ReportBundle\Form\BKP_REFType;

/**
 * BKP_REF controller.
 *
 */
class BKP_REFController extends Controller
{

    /**
     * Lists all BKP_REF entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AriiReportBundle:BKP_REF')->findAll();

        return $this->render('AriiReportBundle:BKP_REF:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new BKP_REF entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new BKP_REF();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bkp_ref_show', array('id' => $entity->getId())));
        }

        return $this->render('AriiReportBundle:BKP_REF:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a BKP_REF entity.
     *
     * @param BKP_REF $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BKP_REF $entity)
    {
        $form = $this->createForm(new BKP_REFType(), $entity, array(
            'action' => $this->generateUrl('bkp_ref_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BKP_REF entity.
     *
     */
    public function newAction()
    {
        $entity = new BKP_REF();
        $form   = $this->createCreateForm($entity);

        return $this->render('AriiReportBundle:BKP_REF:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BKP_REF entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AriiReportBundle:BKP_REF')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BKP_REF entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AriiReportBundle:BKP_REF:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BKP_REF entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AriiReportBundle:BKP_REF')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BKP_REF entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AriiReportBundle:BKP_REF:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a BKP_REF entity.
    *
    * @param BKP_REF $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BKP_REF $entity)
    {
        $form = $this->createForm(new BKP_REFType(), $entity, array(
            'action' => $this->generateUrl('bkp_ref_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BKP_REF entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AriiReportBundle:BKP_REF')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BKP_REF entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bkp_ref_edit', array('id' => $id)));
        }

        return $this->render('AriiReportBundle:BKP_REF:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a BKP_REF entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AriiReportBundle:BKP_REF')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BKP_REF entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bkp_ref'));
    }

    /**
     * Creates a form to delete a BKP_REF entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bkp_ref_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

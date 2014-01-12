<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\ProductBundle\Entity\Product;
use Acme\ProductBundle\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{

    /**
     * Lists all Product products.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AcmeProductBundle:Product')->findAll();

        return $this->render('AcmeProductBundle:Product:index.html.twig', array(
            'products' => $products,
        ));
    }
    /**
     * Creates a new Product.
     *
     */
    public function createAction(Request $request)
    {
        $product = new Product();
        $form = $this->createCreateForm($product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $product->getId())));
        }

        return $this->render('AcmeProductBundle:Product:new.html.twig', array(
            'product' => $product,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Product.
    *
    * @param Product $product The Product
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Product $product)
    {
        $form = $this->createForm(new ProductType(), $product, array(
            'action' => $this->generateUrl('product_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-primary')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Product.
     *
     */
    public function newAction()
    {
        $product = new Product();
        $form   = $this->createCreateForm($product);

        return $this->render('AcmeProductBundle:Product:new.html.twig', array(
            'product' => $product,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AcmeProductBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeProductBundle:Product:show.html.twig', array(
            'product'      => $product,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Product.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AcmeProductBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product.');
        }

        $editForm = $this->createEditForm($product);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeProductBundle:Product:edit.html.twig', array(
            'product'      => $product,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Product.
    *
    * @param Product $product The Product
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Product $product)
    {
        $form = $this->createForm(new ProductType(), $product, array(
            'action' => $this->generateUrl('product_update', array('id' => $product->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Product.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AcmeProductBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($product);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }

        return $this->render('AcmeProductBundle:Product:edit.html.twig', array(
            'product'      => $product,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Product.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('AcmeProductBundle:Product')->find($id);

            if (!$product) {
                throw $this->createNotFoundException('Unable to find Product.');
            }

            $em->remove($product);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    /**
     * Creates a form to delete a Product by id.
     *
     * @param mixed $id The id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}

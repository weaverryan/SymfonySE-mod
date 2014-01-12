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
     * Lists all products.
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
     * Finds and displays a Product.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AcmeProductBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product.');
        }

        return $this->render('AcmeProductBundle:Product:show.html.twig', array(
            'product'      => $product,
        ));
    }

    /**
     * Creates a new Product.
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createProductForm($product);
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
     * Edits an existing Product.
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AcmeProductBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product.');
        }

        $form = $this->createProductForm($product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }

        return $this->render('AcmeProductBundle:Product:edit.html.twig', array(
            'product'      => $product,
            'form'         => $form->createView(),
        ));
    }

    /**
    * Creates a Form for the product
    *
     * @param Product $product
     * @return \Symfony\Component\Form\Form
     */
    private function createProductForm(Product $product)
    {
        if ($product->getId()) {
            $action = $this->generateUrl('product_edit', array('id' => $product->getId()));
            $buttonLabel = 'Update';
        } else {
            $action = $this->generateUrl('product_new');
            $buttonLabel = 'Create';
        }

        $form = $this->createForm(new ProductType(), $product, array(
            'action' => $action,
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => $buttonLabel,
            'attr' => array('class' => 'btn btn-primary')
        ));

        return $form;
    }
}

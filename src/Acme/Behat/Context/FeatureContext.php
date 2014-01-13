<?php

namespace Acme\Behat\Context;

use Acme\ProductBundle\Entity\Product;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Session;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Context\Step\When;
use Behat\Behat\Context\Step\Then;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    protected static $kernel;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // not used - just here as an example of using configuration - see behat.yml
        $screenshotPath = $parameters['screenshots_path'];

        $this->useContext('mink', new MinkContext());

        require_once __DIR__.'/../../../../app/autoload.php';
        require_once __DIR__.'/../../../../app/AppKernel.php';
        self::$kernel = new \AppKernel('test', true);
        self::$kernel->boot();
    }

    /**
     * @Given /^there is a product called "([^"]*)"$/
     */
    public function thereIsAProductCalled($productName)
    {
        $product = new Product();
        $product->setName($productName);
        $product->setPrice(rand(500, 1000));

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^I click "([^"]*)"$/
     */
    public function iClick($linkName)
    {
        return new When(sprintf('I follow "%s"', $linkName));
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->getSubcontext('mink')->getSession();
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    public function getPage()
    {
        return $this->getSession()->getPage();
    }

    /**
     * Clears the database before every scenario
     *
     * @BeforeScenario
     */
    public function clearDatabase()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     * @BeforeScenario
     * @BeforeOutlineExample
     */
    public function bootKernel()
    {
        self::$kernel->boot();
    }

    /**
     * @AfterScenario
     * @AfterOutlineExample
     */
    public function shutdownKernel()
    {
        self::$kernel->shutdown();
    }

    public function getContainer()
    {
        return self::$kernel->getContainer();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.default_entity_manager');
    }
}

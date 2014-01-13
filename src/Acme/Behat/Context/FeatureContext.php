<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Session;

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
}

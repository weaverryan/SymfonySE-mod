Feature: Product Admin
  In order to manage the products on the site
  As a product admin
  I need to be able to list/edit/create products

  Scenario: Listing Products
    Given there is a product called "FooProduct"
    When I go to "/"
    And I click "Products"
    Then I should see "Product list"
    And I should see "FooProduct"

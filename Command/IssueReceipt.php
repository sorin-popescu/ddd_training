<?php

namespace Command;

class IssueReceipt
{
    private $rollNumber;
    private $issueDate;
    private $products;

    /**
     * IssueReceipt constructor.
     * @param string $rollNumber
     * @param string $issueDate
     * @param array $products
     */
    public function __construct(string $rollNumber, string $issueDate, array $products)
    {
        $this->rollNumber = $rollNumber;
        $this->issueDate = $issueDate;
        $this->products = $products;
    }

    /**
     * @return string
     */
    public function getRollNumber()
    {
        return $this->rollNumber;
    }

    /**
     * @return string
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
}

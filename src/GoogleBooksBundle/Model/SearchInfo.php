<?php
/**
 * Created by PhpStorm.
 * User: programista
 * Date: 28.10.18
 * Time: 12:04
 */

namespace GoogleBooksBundle\Model;


/**
 * Class SearchInfo
 * @package BookBundle\Model
 */
class SearchInfo
{
    /**
     * @var string
     */
    private $textSnippet;

    /**
     * SearchInfo constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param array $searchInfoData
     * @return SearchInfo
     */
    public static function create(array $searchInfoData): SearchInfo
    {
        $return = new SearchInfo();

        $return
            ->setTextSnippet($searchInfoData["textSnippet"]);

        return $return;
    }

    /**
     * @return string
     */
    public function getTextSnippet(): string
    {
        return $this->textSnippet;
    }

    /**
     * @param string $textSnippet
     * @return SearchInfo
     */
    public function setTextSnippet(string $textSnippet): SearchInfo
    {
        $this->textSnippet = $textSnippet;
        return $this;
    }


}
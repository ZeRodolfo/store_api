<?php

namespace App\Lib;


class Paginator {
  private $totalPages;
  private $page;
  private $perPage;
  private $currentPage;

  public function __construct($page, $perPage = 2) {
    $this->perPage = $perPage;
    $this->page = $page;
    $this->currentPage = 1;

    $totalCount = count($page);
    $this->totalPages = $this->setTotalPages($totalCount, $perPage);
  }

  private function setTotalPages($totalCount, $perPage) {
    if ($perPage == 0) {
      $perPage = 5;
    }

    $this->totalPages = ceil($totalCount / $perPage);
    
    return $this->totalPages;
  }

  public function getTotalPages() {
    return $this->totalPages;
  }

  public function setCurrentPage($currentPage = 1) {
    $this->currentPage = $currentPage;
    
    return $this;
  }

  public function paginate($pageNumber=NULL) {
    $totalPages = $this->totalPages;
    $perPage = $this->perPage;
    $currentPage = $this->currentPage > 0 ? $this->currentPage - 1 : 0;

    if ($pageNumber !== NULL) {
      $currentPage = $pageNumber > 0 ? $pageNumber - 1 : $currentPage;
    }

    $initialPage = $currentPage * $perPage;

    $page = array_slice($this->page, $initialPage, $perPage);
    
    $this->currentPage = $currentPage + 1;

    return [
      'perPage' => $perPage,
      'totalPages' => $totalPages,
      'currentPage' => $this->currentPage,
      'data' => $page
    ];
  }
}
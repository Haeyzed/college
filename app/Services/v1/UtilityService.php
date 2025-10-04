<?php

namespace App\Services\v1;

use App\Enums\v1\BookStatus;
use App\Enums\v1\BookCategoryStatus;
use App\Enums\v1\BookRequestStatus;
use App\Enums\v1\MemberType;
use App\Enums\v1\IssueStatus;
use App\Enums\v1\Status;
use App\Enums\v1\Gender;
use App\Enums\v1\MaritalStatus;
use App\Enums\v1\BloodGroup;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * UtilityService - Version 1
 *
 * Service for providing utility functions and data for the College Management System.
 * This service handles enum fetching and other utility operations.
 *
 * @package App\Services\v1
 * @version 1.0.0
 * @author Softmax Technologies
 */
class UtilityService
{
    /**
     * Get book status enum.
     *
     * @return array
     */
    public function getBookStatusEnum(): array
    {
        return BookStatus::options();
    }

    /**
     * Get book category status enum.
     *
     * @return array
     */
    public function getBookCategoryStatusEnum(): array
    {
        return BookCategoryStatus::options();
    }

    /**
     * Get book request status enum.
     *
     * @return array
     */
    public function getBookRequestStatusEnum(): array
    {
        return BookRequestStatus::options();
    }

    /**
     * Get member type enum.
     *
     * @return array
     */
    public function getMemberTypeEnum(): array
    {
        return MemberType::options();
    }

    /**
     * Get issue status enum.
     *
     * @return array
     */
    public function getIssueStatusEnum(): array
    {
        return IssueStatus::options();
    }

    /**
     * Get status enum.
     *
     * @return array
     */
    public function getStatusEnum(): array
    {
        return $this->getEnumData(Status::class);
    }

    /**
     * Get gender enum.
     *
     * @return array
     */
    public function getGenderEnum(): array
    {
        return Gender::options();
    }

    /**
     * Get marital status enum.
     *
     * @return array
     */
    public function getMaritalStatusEnum(): array
    {
        return MaritalStatus::options();
    }

    /**
     * Get blood group enum.
     *
     * @return array
     */
    public function getBloodGroupEnum(): array
    {
        return BloodGroup::options();
    }
}

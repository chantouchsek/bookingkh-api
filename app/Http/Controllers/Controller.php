<?php

namespace App\Http\Controllers;

use App\Concerns\Restable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\OpenApi(
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="API Development Server"
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST_STAGING,
 *         description="API Staging Server"
 *     ),
 *     @OA\Info(
 *         version="0.0.1",
 *         title="Widsley API Documentation",
 *         description="Bookingkh api to demonstrate features in the Bookingkh Job Portal",
 *         termsOfService="http://swagger.io/terms/",
 *         @OA\Contact(name="Touch Developer at Mango Byte", email="s.chantouch@mango-byte.com"),
 *         @OA\License(
 *              name="Apache 2.0",
 *              url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *          )
 *     )
 * )
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Restable;

    /**
     * The default pagination size.
     *
     * @var int The pagination size
     */
    protected $pagination = 20;
    /**
     * The maximum pagination size.
     *
     * @var int The pagination size
     */
    protected $maxLimit = 500;
    /**
     * The minimum pagination size.
     *
     * @var int The pagination size
     */
    protected $minLimit = 1;

    /**
     * Getter for the pagination.
     *
     * @return int The pagination size
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Sets and checks the pagination.
     *
     * @param int $pagination The given pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = (int) $this->checkPagination($pagination);
    }

    /**
     * Checks the pagination.
     *
     * @param * $pagination The pagination
     *
     * @return int The corrected pagination
     */
    private function checkPagination($pagination)
    {
        // Pagination should be numeric
        if (! is_numeric($pagination)) {
            return $this->pagination;
        }
        // Pagination should not be less than the minimum limitation
        if ($pagination < $this->minLimit) {
            return $this->minLimit;
        }
        // Pagination should not be greater than the maximum limitation
        if ($pagination > $this->maxLimit) {
            return $this->maxLimit;
        }
        // If the pagination is between the min limit and the max limit, return the pagination
        if (! ($pagination > $this->maxLimit) && ! ($pagination < $this->minLimit)) {
            return $pagination;
        }

        // If all fails, return the default pagination
        return $this->pagination;
    }
}

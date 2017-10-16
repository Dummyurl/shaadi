<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{
	protected $table = TBL_PORTFOLIOS_CATEGORIES;

	protected $fillable = ['title'];
}

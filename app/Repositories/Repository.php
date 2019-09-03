<?php

namespace App\Repositories;

interface Repository
{
	function get();

	function where(array $attributes );

    function find($id);

	function create(array $attributes);

	function update($id, array $attributes);

	function delete($id);
}

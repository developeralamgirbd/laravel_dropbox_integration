<?php

namespace App\Rules;

use App\Models\DropboxCrud;
use Illuminate\Contracts\Validation\Rule;

class ThrottleSubmission implements Rule
{
    protected $dropboxCrud;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(DropboxCrud $dropboxCrud)
    {
        $this->dropboxCrud = $dropboxCrud;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->dropboxCrud->img_url != null ? $this->dropboxCrud->created_at->It(now()->subMinutes(5)): null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}

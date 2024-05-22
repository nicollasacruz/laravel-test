<?php

declare(strict_types=1);

namespace Tests\Exam;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * j_UserInvitationTest
 * - On this test we will check if you know how to:
 *
 * 1. Analyze a working feature and develop tests for it
 *
 * To develop your tests, you must take a look on the following files
 * - app/Http/Controllers/InvitationController.php
 * - app/Requests/Invitation
 * - app/Mail/InviteUser.php
 * - app/Models/Invitation.php
 * - routes/web.php
 */
class j_UserInvitationTest extends TestCase
{
    #[Test]
    public function it_should_allow_access_to_invite_only_for_logged_users(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_if_email_is_filled_for_the_new_invitation(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_if_email_address_is_valid_for_the_new_invitation(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_email_size_for_new_invitation(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_create_an_invitation_and_send_it_to_user()
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_deny_invitation_acceptance_if_invitation_has_been_expired(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function should_deny_invitation_acceptance_if_invitation_has_already_been_accepted(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_if_email_provided_matches_with_invitation_email(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_if_email_already_exists_on_users_table(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_it_should_ensure_that_email_is_filled_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_email_address_is_valid_for_registrations(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_email_length_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_name_is_filled_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_name_is_a_string_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_name_min_length_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_validate_name_max_length_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_password_is_filled_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_password_was_confirmed_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_check_if_password_has_at_least_eight_chars_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_password_has_symbols_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_password_has_letters_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_ensure_that_password_has_numbers_for_registration(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function it_should_accept_the_invitation_and_create_a_new_user(): void
    {
        $this->assertTrue(false);
    }
}

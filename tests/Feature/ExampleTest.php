<?php

it('redirects unauthenticated users from root to login', function () {
    $response = $this->get('/');

    $response->assertRedirect('/admin/login');
});

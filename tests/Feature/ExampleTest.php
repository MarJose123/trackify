<?php

it('returns a successful response', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

<?php
function generalException($destination)
{
    return redirect()->route($destination)->with('error', 'something went wrong!');
}



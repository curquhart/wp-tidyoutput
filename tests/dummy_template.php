<?php

// This file is used to fake a template outputting something. It should be
// included, some output sent, and then set as the template callback. Note that
// it is assumed that the DummyOutput class exists prior to including this file.

namespace TidyOutput;

echo DummyOutput::get_output();

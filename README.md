GPT-3 API Experiment
====================

This repository contains an experiment with the GPT-3 API from OpenAI, aiming to apply it to an everyday problem. Specifically, the goal was to create an application that scrapes the 10 latest news articles (within the last 24 hours) related to Artificial Intelligence from Google News Search, summarizes them, and generates a short article as an update on new AI achievements and insights worldwide.

Challenges
----------

During the development of the application, the following challenges were faced:

*   GPT-3 works with old data, so it needs to be updated before processing new information.
*   The API has a limit on the number of tokens that can be processed, which restricts the input size.
*   There is no caching available for the API, so data uploaded cannot be used in later queries.
*   The API processing commands differ from those of chatGPT, leading to different results.
*   The available GPT-3 API uses a generic model that is not specifically optimized for chat.

Learnings
---------

Some key takeaways from the experiment are:

*   Working with the OpenAI API is fun, but not as straightforward as chatGPT.
*   The current version of GPT-3 can still not handle enough information to generate high-quality content.
*   The cost of the API is fair, but the options are limited without additional model training or fine-tuning.

Usage
-----

To use this code, you will need to have a valid OpenAI API key as well as a SerpWOW API key and install the necessary packages listed in the requirements file. After setting up the API connection and collecting news articles, run the index.php file to generate the summarized article.

```
// run the webserver first
php -S localhost:9000

/initially install the needed packages
composer install
```

Then open your browser at http://localhost:9000/ and wait


License
-------

This project is licensed under the MIT License - see the LICENSE file for details.

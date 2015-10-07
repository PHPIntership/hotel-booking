#!/usr/bin/env bash

if [ -z "${CI_PULL_REQUEST}" ]; then
    exit 0
fi

phpcs -n --report=checkstyle --standard=phpcs.xml \
    | checkstyle_filter-git diff origin/master \
    | saddler report --require saddler/reporter/github --reporter Saddler::Reporter::Github::PullRequestReviewComment

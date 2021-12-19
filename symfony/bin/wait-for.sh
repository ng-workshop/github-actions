#!/usr/bin/env sh

RED=$(tput -Txterm setaf 1)
GREEN=$(tput -Txterm setaf 2)
YELLOW=$(tput -Txterm setaf 3)
BLUE=$(tput -Txterm setaf 4)
BOLD=$(tput -Txterm bold)
RESET=$(tput -Txterm sgr0)
ERROR="ERROR"
SUCCESS="SUCCESS"
WARNING="WARNING"
INFO="INFO"
DEFAULT_TIMEOUT=60
INTERVAL=1

#set -x

wait_for()
{
  if [ "${TIMEOUT}" -gt 0 ]; then
      print_message "Waiting ${TIMEOUT} seconds for ${HOST}:${PORT}" "${INFO}"
  else
      print_message "Waiting for ${HOST}:${PORT} without a timeout" "${INFO}"
  fi

  for I in $(seq 0 "${INTERVAL}" "${TIMEOUT}")
  do
    printf "%c" "."

    if [ "${I}" = "${TIMEOUT}" ]
    then
      print_message "${HOST}:${PORT} is not available after ${I} seconds" "${ERROR}"
      exit 1
    fi

    nc -z "${HOST}" "${PORT}"

    RESULT=$?

    if [ ${RESULT} -eq 0 ]
    then
      print_message "${HOST}:${PORT} is available after ${I} seconds" "${INFO}"
      break
    fi

    sleep "${INTERVAL}"
  done
}

set_host()
{
  if [ -n "${HOST}" ]
  then
    print_message "Host is already defined. Current value is \"${HOST}\" and new value is \"${1}\"" "${ERROR}"
    usage
    exit 1
  fi

  HOST="${1}"
}

set_port()
{
  if [ -n "${PORT}" ]
  then
    print_message "Port is already defined. Current value is \"${PORT}\" and new value is \"${1}\"" "${ERROR}"
    usage
    exit 1
  fi

  PORT="${1}"
}

set_timeout()
{
  if [ -n "${TIMEOUT}" ]
  then
    print_message "Timeout is already defined. Current value is \"${TIMEOUT}\" and new value is \"${1}\"" "${ERROR}"
    usage
    exit 1
  fi

  TIMEOUT="${1}"
}

print_message()
{
  MESSAGE="${1}"
  MESSAGE_TYPE="${2}"

  if [ -z "${MESSAGE}" ]
  then
    print_message "Missing first argument \"message\" for \"print_message\" function." "${ERROR}"
    exit 1
  fi

  if [ -z "${MESSAGE_TYPE}" ]
  then
    print_message "Missing second argument \"message-type\" for \"print_message\" function." "${ERROR}"
    exit 1
  fi

  case "${MESSAGE_TYPE}" in
    "${ERROR}") MESSAGE="${RED}${BOLD}[ERROR]:${RESET}${RED} ${MESSAGE}${RESET}";;
    "${SUCCESS}") MESSAGE="${GREEN}${BOLD}[SUCCESS]:${RESET}${GREEN} ${MESSAGE}${RESET}";;
    "${WARNING}") MESSAGE="${YELLOW}${BOLD}[WARNING]:${RESET}${YELLOW} ${MESSAGE}${RESET}";;
    "${INFO}") MESSAGE="${BLUE}${BOLD}[INFO]:${RESET}${BLUE} ${MESSAGE}${RESET}";;
    *)
      print_message "Invalid message-type \"${MESSAGE_TYPE}\" for \"print_message\" function." "${WARNING}"
      return
      ;;
  esac

  printf "\n%s\n" "${MESSAGE}"
}

usage()
{
  printf "
%sUsage: wait_for.sh [OPTIONS]%s
    -h HOST | -h=HOST | --host HOST | --host=HOST                       Host or IP under test
    -p PORT | -p=PORT | --port PORT | --port=PORT                       Port under test
                                                                        Alternatively, you specify the host and port as host:port
    -t TIMEOUT | -t=TIMEOUT | --timeout TIMEOUT | --timeout=TIMEOUT     Timeout in seconds, zero for no timeout
    --help                                                              Show usage
" "${BLUE}" "${RESET}"
}

main()
{
  while [ $# -gt 0 ]
  do
    case "$1" in
        *:* )
          set_host "$(echo "${1}" | cut -d":" -f1)"
          set_port "$(echo "${1}" | cut -d":" -f2)"
          shift 1
        ;;
        -h | --host)
          set_host "$2"
          shift 2
        ;;
        -h=* | --host=*)
          set_host "${1#*=}"
          shift 1
        ;;
        -p | --port)
          set_port "$2"
          shift 2
        ;;
        -p=* | --port=*)
          set_port "${1#*=}"
          shift 1
        ;;
        -t | --timeout)
          set_timeout "$2"
          shift 2
        ;;
        --timeout=*)
          set_timeout "${1#*=}"
          shift 1
        ;;
        --help)
          usage
          exit 0
        ;;
        *)
          print_message "Unknown argument: $1" "${ERROR}"
          usage
          exit 1
        ;;
    esac
  done

  if [ -z "${HOST}" ]
  then
    print_message "Host is not defined" "${ERROR}"
    exit 1
  fi

  if [ -z "${PORT}" ]
  then
    print_message "Port is not defined" "${ERROR}"
    exit 1
  fi

  if [ -z "${TIMEOUT}" ]
  then
    print_message "Timeout is not defined. But is define to default value: \"${DEFAULT_TIMEOUT}\" seconds" "${WARNING}"
    TIMEOUT="${DEFAULT_TIMEOUT}"
  fi

  wait_for
}

main "${@}"

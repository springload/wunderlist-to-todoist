#!/usr/bin/env ruby

require "fileutils"
require "pathname"

def sanitize_filename(filename)
  # Split the name when finding a period which is preceded by some
  # character, and is followed by some character other than a period,
  # if there is no following period that is followed by something
  # other than a period (yeah, confusing, I know)
  fn = filename.split(/(?<=.)\.(?=[^.])(?!.*\.[^.])/m)

  # We now have one or two parts (depending on whether we could find
  # a suitable period). For each of these parts, replace any unwanted
  # sequence of characters with an underscore
  fn.map! { |s| s.gsub(/[+*:]/, '') }
  fn.map! { |s| s.gsub(/[\/ ]/, '_') }

  # Finally, join the parts with a period and return the result
  return fn.join '.'
end

divider = "----------------------------------------\n"
text = ARGF.read

text.gsub!(/\n{3,}/,"\n" + divider)
projects = text.split(divider)

dirname = "./projects"
FileUtils.mkdir_p(dirname)

projects.each do |textproj|
  list = textproj.split("\n")
  next if list.empty?

  filename = ""
  filepath = Pathname.new(dirname)
  aryproj = []
  
  list.each_with_index do |line, i|
    if i == 0 # Project name
      filename = "project_" + sanitize_filename(line) + ".txt"
      filepath += filename
      puts "PROJECT: " + line
    end # Tasks
    aryproj.push(line)
  end

  File.open(filepath, "w+") do |f|
    f.puts(aryproj)
  end
end

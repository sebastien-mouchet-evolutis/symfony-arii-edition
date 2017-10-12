#!/usr/bin/perl
# Transformation d'un autorep -q
#
$spooler='VA1';

@Cols = ('job_name','insert','delete');
print "spooler_name\t".join("\t",@Cols)."\n";
my %Job;
while (<STDIN>) {
	chomp;	
	s/[\n\r]$//;
	s/^\s*//;
	s/\s*$//;
	next if /^$/;
	next if /^\s\/*/;
	if (/^(\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2})/) {
		$date = $1;
	}
	elsif (/(insert|delete)_job: (.*)/) {
		$Job{$2}->{$1} = $date;
	}
}

foreach my $j (sort keys %Job) {
	print "$spooler\t$j\t$Job{$j}->{'insert'}\t$Job{$j}->{'delete'}\n";
}
